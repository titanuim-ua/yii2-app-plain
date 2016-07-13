<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 2016-04-21
 * Time: 15:38
 */

namespace app\components\postcss;


class Autoprefixer
{
    private static function exec($cmd, $in)
    {
        $spec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("pipe", "w") // stderr
        );
        $p = proc_open($cmd, $spec, $pipes, \Yii::$app->basePath . "/js-core/");

        if (!is_resource($p))
            throw new \Exception("Cannot create process");

        fwrite($pipes[0], $in);
        fclose($pipes[0]);

        $out = stream_get_contents($pipes[1]);

        $err = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $return_value = proc_close($p);

//        $this->lastResponse = ["out" => $out, "err" => $err];

//        print_r([$in, $out, $err]);

//        $out = json_decode($out, true);

        if ($err)
            throw new \Exception("JS error: $err\n" . print_r([/*"in" => $in, */"out" => $out, "code" => $return_value], true));

//        $this->state = $out["state"];

        return $out;
    }

    public static function lessFile($path)
    {
        return self::exec('node less.js "'.$path.'"', "");
    }

    public static function less($str)
    {
        return self::exec('node less.js -', $str);
    }

    public static function css($css)
    {
        return self::exec('node autoprefixer.js', $css);
    }
}