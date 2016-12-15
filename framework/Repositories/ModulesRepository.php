<?php
namespace SleepingOwl\Framework\Repositories;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Nwidart\Modules\Repository;

class ModulesRepository extends Repository
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * ModulesRepository constructor.
     *
     * @param Application $app
     * @param Filesystem $filesystem
     * @param null $path
     */
    public function __construct(Application $app, Filesystem $filesystem, $path = null)
    {
        parent::__construct($app, $path);
        $this->files = $filesystem;
    }

    /**
     * Get all modules.
     *
     * @return array
     */
    public function all()
    {
        if (! $this->app->environment('production')) {
            if ($this->files->exists($this->manifestPath())) {
                $this->files->delete($this->manifestPath());
            }

            return $this->scan();
        }

        return $this->formatCached($this->getCached());
    }

    /**
     * Get cached modules.
     *
     * @return array
     */
    public function getCached()
    {
        if ($this->files->exists($this->manifestPath())) {
            $manifest = $this->files->getRequire($this->manifestPath());

            if ($manifest) {
                return $manifest;
            }
        }

        $manifest = $this->toCollection()->toArray();

        $this->files->put($this->manifestPath(), '<?php return '.var_export($manifest, true).';');

        return $manifest;
    }

    /**
     * @return string
     */
    protected function manifestPath()
    {
        return $this->app->bootstrapPath().'/cache/modules.php';
    }
}