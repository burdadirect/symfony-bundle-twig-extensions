<?php

namespace HBM\TwigExtensionsBundle\Twig\Node;

use LogicException;
use Twig\Compiler;
use Twig\Node\Node;

class TryCatchNode extends Node
{
    public const NODE_TRY = 'hbm_try';
    public const NODE_CATCH = 'hbm_catch';

    public function __construct(Node $try, Node $catch = null, int $lineno = 0, string $tag = null)
    {
        $nodes = [self::NODE_TRY => $try, self::NODE_CATCH => $catch];
        $nodes = array_filter($nodes);

        parent::__construct($nodes, [], $lineno, $tag);
    }

    /**
     * @throws LogicException
     */
    public function compile(Compiler $compiler): void
    {
        $compiler->addDebugInfo($this);

        ob_start();
        $compiler->write('try {'."\n");
        $compiler->write('ob_start();');

        $compiler
            ->indent()
            ->subcompile($this->getNode(self::NODE_TRY))
            ->outdent()
            ->write('} catch (\Throwable $e) {' . "\n")
            ->indent()
            ->write('ob_clean();'."\n")
            ->write('$context[\'e\'] = $e;' . "\n");

        if ($this->hasNode(self::NODE_CATCH)) {
            $compiler->subcompile($this->getNode(self::NODE_CATCH));
        }

        $compiler
            ->outdent()
            ->write("} finally {\n")
            ->indent()
            ->write('ob_end_flush();'."\n")
            ->outdent()
            ->write("}\n");
    }
}
