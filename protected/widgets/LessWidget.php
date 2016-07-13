<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 2015-08-13
 * Time: 20:48
 */

namespace app\widgets;


use app\components\postcss\Autoprefixer;
use yii\base\Widget;

class LessWidget extends Widget
{

    public function init()
    {
        ob_start();
    }
    public function run()
    {
        $code = ob_get_clean();

        $cacheId = 'less-inline#' . md5($code);
        $cache = \Yii::$app->cache->get($cacheId);
        if ($cache === false) {
//            $less = new \lessc();
//            $cache = $less->compile($code);
            $cache = Autoprefixer::less($code);

            \Yii::$app->cache->set($cacheId, $cache, 60*60*2);
        }

        echo "$cache";
    }

}