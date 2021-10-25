<?php
namespace app\engine;
class Autoload
{
    public function loadClass($className)
    {
        //код с регуляркой хуже читается и работает  медленнее
//        $patterns = ['/\\\\/', '/\b(app)/'];
//        $replacements = ['/', '..'];
//        $fileName =  preg_replace($patterns, $replacements, "$className.php");
          $count = 1;
          $fileName = str_replace('app', ROOT, $className, $count);
          $fileName = str_replace('\\', DS, $fileName) . '.php';

          if (file_exists($fileName)) {
                include $fileName;
          }
    }
}