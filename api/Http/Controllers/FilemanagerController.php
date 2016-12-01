<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use SleepingOwl\Api\Contracts\Manager;

class FilemanagerController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
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
    public function listFiles(Request $request)
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
            )
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function delete(Request $request)
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
     * @param array $files
     *
     * @return Collection
     */
    protected function getMetaInformation(array $files)
    {
        return collect($files)->map(function ($path) {
            return $this->filesystem->getMetadata($path);
        });
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file',
            'path' => 'string'
        ]);

        $file = $request->file('file');

        $request->file('file')
            ->storeAs(
                $request->input('path'),
                $file->getClientOriginalName(),
                config('sleepingowl.filemanager_disk')
            );

        return $this->listFiles($request);
    }
}