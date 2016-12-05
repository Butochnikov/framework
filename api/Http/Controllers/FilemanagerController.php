<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use SleepingOwl\Api\Contracts\Manager;

class FilemanagerController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    private $filesystem;

    /**
     * @param Manager $manager
     * @param FilesystemContract $filesystem
     */
    public function __construct(Manager $manager, FilesystemContract $filesystem)
    {
        parent::__construct($manager);
        $this->filesystem = $filesystem->disk(config('sleepingowl.filemanager_disk'));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @internal param string $path
     */
    public function listFiles(Request $request): JsonResponse
    {
        $this->validate($request, [
            'path' => 'string'
        ]);

        return new JsonResponse([
            'files' => $this->filesystem->listContents(
                $request->input('path')
            ),
            'directories' => $this->getMetaInformation(
                $this->filesystem->directories(
                    $request->input('path')
                )
            ),
            //'tree' => $this->pathsToTree(array_combine($directories, $directories))
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function download(Request $request): Response
    {
        $this->validate($request, [
            'file' => 'required|string'
        ]);

        $file = $request->input('file');

        $size = $this->filesystem->size($file);
        $mime = $this->filesystem->mimeType($file);
        $filename = pathinfo($file, PATHINFO_BASENAME);
        $response = new Response(
            $this->filesystem->get(
                $file
            )
        );

        if ('HTTP/1.0' !== $request->server->get('SERVER_PROTOCOL')) {
            $response->setProtocolVersion('1.1');
        }

        $response->headers->add([
            'Accept-Ranges' => $request->isMethodSafe() ? 'bytes' : 'none',
            'Content-type' => $mime ?: 'application/octet-stream',
            'Pragma' => 'public',
            'Expires' => 0,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Content-transfer-encoding' => 'binary',
            'Content-Length' =>  $size,
        ]);

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function makeDirectory(Request $request): JsonResponse
    {
        $this->validate($request, [
            'path' => 'required|string'
        ]);

        $this->filesystem->makeDirectory(
            $request->input('path')
        );

        return $this->listFiles($request);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $this->validate($request, [
            'file' => 'required|string'
        ]);

        $this->filesystem->delete(
            $request->input('file')
        );

        return $this->listFiles($request);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteDirectory(Request $request): JsonResponse
    {
        $this->validate($request, [
            'dir' => 'required|string'
        ]);

        $this->filesystem->deleteDirectory(
            $request->input('dir')
        );

        return $this->listFiles($request);
    }

    /**
     * @param array $files
     *
     * @return Collection
     */
    protected function getMetaInformation(array $files): Collection
    {
        return collect($files)->map(function ($path) {
            return $this->filesystem->getMetadata($path);
        })->map(function ($data) {
            $data['basename'] = pathinfo($data['path'], PATHINFO_BASENAME);
            return $data;
        });
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function upload(Request $request): JsonResponse
    {
        $this->validate($request, [
            'file' => 'required|file',
            'path' => 'string'
        ]);

        $file = $request->file('file');

        $this->filesystem->putFileAs(
            $request->input('path'),
            $file,
            $file->getClientOriginalName()
        );

        return $this->listFiles($request);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function pathsToTree(array $array): array
    {
        $splitRE = '/'.preg_quote('/', '/').'/';

        $return = [];
        foreach ($array as $key => $val) {
            // Get parent parts and the current leaf
            $parts = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
            $leafPart = array_pop($parts);

            // Build parent structure
            // Might be slow for really deep and large structures
            $parent = &$return;
            foreach ($parts as $part) {
                if (! isset($parent[$part])) {
                    $parent[$part] = [];
                } elseif (! is_array($parent[$part])) {
                    $parent[$part] = [];
                }
                $parent = &$parent[$part];
            }

            // Add the final part to the structure
            if (empty($parent[$leafPart])) {
                $parent[$leafPart] = $val;
            }
        }

        return $return;
    }
}