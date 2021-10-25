<?php

class Autoload
{

    public function loadClass($className)
    {
        $patterns = ['/\\\\/', '/\b(app)/'];
        $replacements = ['/', '..'];
        $fileName =  preg_replace($patterns, $replacements, "$className.php");
            if (file_exists($fileName)) {
                include $fileName;
            }
    }
}