<?php

/*
 * This file is part of the Indigo Doris package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doris\Stub;

/**
 * Test Command
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class TestCommand
{
    public $data = true;

    /**
     * Returns the data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
