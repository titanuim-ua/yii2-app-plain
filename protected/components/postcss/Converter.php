<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 2016-04-21
 * Time: 19:46
 */

namespace app\components\postcss;



use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

class Converter extends \yii\web\AssetConverter
{
    /**
     * @var boolean if true the asset will always be published
     */
    public $force = false;

    /**
     * @var string some directory in @webroot for compiled files. Will using like Yii::getAlias('@webroot/' . $this->destinationDir)
     */
    public $destinationDir = 'compiled';

    /**
     * @var string permissions to assign to $destinationDir.
     */
    public $destinationDirPerms = 0755;

    public function convert($asset, $basePath)
    {
        $pos = strrpos($asset, '.');
        if ($pos === false) {
            return parent::convert($asset, $basePath);
        }

        $ext = substr($asset, $pos + 1);
        if ($ext!="less") {
            return parent::convert($asset, $basePath);
        }

        if ($this->destinationDir) {
            $this->destinationDir .= '/';
        }
        $resultFile = substr($asset, 0, $pos + 1) . "compiled.css";
        //$resultFile = $this->destinationDir . substr($asset, 0, $pos + 1) . $parserConfig['output'];

        $from = $basePath . '/' . $asset;
        $to = $basePath . '/' . $resultFile;

        if (!$this->needRecompile($from, $to)) {
            return $resultFile;
        }

        $this->checkDestinationDir($basePath, $resultFile);

        $md5Hit="true";
        $k = "asset-less-to-css-".md5(file_get_contents($from));
        $css = Yii::$app->cache->get($k);
        if (!$css) {
            $md5Hit="false";
            $css = Autoprefixer::lessFile($from);
            Yii::$app->cache->set($k, $css, 60*60*15);
        }
        file_put_contents($to, $css);

        if (YII_DEBUG) {
            Yii::info("Converted $asset into $resultFile (md5 hit = $md5Hit)", __CLASS__);
        }

        return $resultFile;
    }

    public function needRecompile($from, $to)
    {
        return $this->force || !file_exists($to) || (@filemtime($to) < filemtime($from));
    }

    public function checkDestinationDir($basePath, $file)
    {
        $distDir = dirname($basePath . '/' . $file);
        if (!is_dir($distDir)) {
            mkdir($distDir, $this->destinationDirPerms, true);
        }
    }
}
