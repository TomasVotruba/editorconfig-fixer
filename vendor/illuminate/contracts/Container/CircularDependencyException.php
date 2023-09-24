<?php

namespace EditorconfigFixer202309\Illuminate\Contracts\Container;

use Exception;
use EditorconfigFixer202309\Psr\Container\ContainerExceptionInterface;
class CircularDependencyException extends Exception implements ContainerExceptionInterface
{
    //
}
