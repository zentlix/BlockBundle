<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\Application\Command\Block;

use Symfony\Component\HttpFoundation\Request;
use Zentlix\MainBundle\Application\Command\CreateCommandInterface;

class CreateCommand extends Command implements CreateCommandInterface
{
    public function __construct(Request $request = null)
    {
        if($request) {
            $this->title = $request->request->get('title');
            $this->code = $request->request->get('code');
            $this->description = $request->request->get('description');
            $this->content = $request->request->get('content');
            $this->cache_group = (string) $request->request->get('cache_group', 'default');
            $this->type = (string) $request->request->get('type', 'html');
        }
    }
}