<?php

namespace App\Helpers;

/**
 * Interface IMMPConfig
 *
 * @package App\Helpers
 */
interface IMMPConfig
{
    const MMP_ID     = '__sigma_mmp_';

    const EDGE = [
        'prefix' => '_edge_',
        'size'   => 0.00081082912502345
    ];

    const NODE = [
        'prefix' => '_node_',
        'size'   => 0.00081082912502345,
        'type'   => 'star',
        'color'  => '#617db4'
    ];
}
