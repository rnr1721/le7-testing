<?php

namespace Core\Testing\Traits;

trait Fs
{

    public function mkdir(string $dir): bool
    {
        if (file_exists($dir)) {
            return false;
        } else {
            mkdir($dir, 0775, true);
        }
        return true;
    }

    public function rmdir(string $dir):void
    {
        $ds = DIRECTORY_SEPARATOR;
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object !== "." && $object !== "..") {
                    if (is_dir($dir . $ds . $object) && !is_link($dir . "/" . $object)) {
                        $this->rmdir($dir . $ds . $object);
                    } else {
                        unlink($dir . $ds . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }

}
