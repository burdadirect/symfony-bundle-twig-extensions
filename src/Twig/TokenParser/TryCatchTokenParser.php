<?php

namespace HBM\TwigExtensionsBundle\Twig\TokenParser;

use HBM\TwigExtensionsBundle\Twig\Node\TryCatchNode;
use Twig\Error\SyntaxError;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Adds parser for try/catch syntax.
 *
 * <pre>
 * {% hbm_try %}
 *    <li>{{ user.get('name') }}</li>
 * {% hbm_catch %}
 *    {{ e.message }}
 * {% end_hbm_catch %}
 * </pre>
 */
class TryCatchTokenParser extends AbstractTokenParser
{
    /**
     * @throws SyntaxError
     */
    public function parse(Token $token): TryCatchNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(Token::BLOCK_END_TYPE);
        $try = $this->parser->subparse([$this, 'decideCatch']);
        $stream->next();
        $stream->expect(Token::BLOCK_END_TYPE);
        $catch = $this->parser->subparse([$this, 'decideEnd']);
        $stream->next();
        $stream->expect(Token::BLOCK_END_TYPE);

        return new TryCatchNode($try, $catch, $lineno, $this->getTag());
    }

    public function decideCatch(Token $token): bool
    {
        return $token->test([TryCatchNode::NODE_CATCH]);
    }

    public function decideEnd(Token $token): bool
    {
        return $token->test(['end_'.TryCatchNode::NODE_TRY]) || $token->test(['end_'.TryCatchNode::NODE_CATCH]);
    }

    public function getTag(): string
    {
        return TryCatchNode::NODE_TRY;
    }
}
