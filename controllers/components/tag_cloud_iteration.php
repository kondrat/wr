<?php
// @TODO remove this function. Ajust naitive tag componect instead
/**
 * Iterates throught tag cloud taken from CakeDC tags plugin to remove unnessesary 
 * data
 *
 *
 */
class TagCloudIterationComponent extends Object {

    /**
     * iterating throught tag cloud, removing unneseassary data
     * 
     * @access public
     * @param array $res
     * @return type array
     */
    public function iterate($res = array()) {
        if (isset($res)) {
            foreach ($res as $k => $v) {
                unset($res[$k][0]);
                unset($res[$k]['Tagged']);
                unset($res[$k]['Tag']['created']);
                unset($res[$k]['Tag']['id']);
                unset($res[$k]['Tag']['keyname']);
                unset($res[$k]['Tag']['modified']);
            }
        }
        return $res;
    }

}

?>