<?php

namespace HBM\TwigExtensionsBundle\Tests\Twig\Extension;

use HBM\TwigExtensionsBundle\Twig\Extension\MatchesFormatterExtension;
use PHPUnit\Framework\TestCase;

class MatchesFormatterExtensionTest extends TestCase
{
    public function testHbmHighlightMatchesNullOrEmpty(): void
    {
        $this->assertNull(MatchesFormatterExtension::apply(null, ['test']));
        $this->assertSame('Hello World', MatchesFormatterExtension::apply('Hello World', null));
        $this->assertSame('Hello World', MatchesFormatterExtension::apply('Hello World', []));
        $this->assertSame('', MatchesFormatterExtension::apply('', ['test']));
    }

    public function testHbmHighlightMatchesSingleMatch(): void
    {
        $text   = 'Hello World';
        $result = MatchesFormatterExtension::apply($text, 'World', '<u>%s</u>');
        $this->assertSame('Hello <u>World</u>', $result);
    }

    public function testHbmHighlightMatchesMultipleMatches(): void
    {
        $text   = 'The quick brown fox jumps over the lazy dog';
        $result = MatchesFormatterExtension::apply($text, ['quick', 'lazy'], '<u>%s</u>');
        $this->assertSame('The <u>quick</u> brown fox jumps over the <u>lazy</u> dog', $result);
    }

    public function testHbmHighlightMatchesCaseInsensitivePreservingOriginalCase(): void
    {
        $text   = 'Bunte Illustrierte und bunte Blumen';
        $result = MatchesFormatterExtension::apply($text, ['BUNTE'], '<em>%s</em>');
        $this->assertSame('<em>Bunte</em> Illustrierte und <em>bunte</em> Blumen', $result);
    }

    public function testHbmHighlightMatchesOverlappingMatches(): void
    {
        $text   = 'banana';
        $result = MatchesFormatterExtension::apply($text, ['an', 'na'], '<em>%s</em>');
        $this->assertSame('b<em>anana</em>', $result);

        $text2   = 'abcdef';
        $result2 = MatchesFormatterExtension::apply($text2, ['abc', 'cde'], '<em>%s</em>');
        $this->assertSame('<em>abcde</em>f', $result2);

        $text3   = 'aaaa';
        $result3 = MatchesFormatterExtension::apply($text3, ['aa', 'aaa'], '<em>%s</em>');
        $this->assertSame('<em>aaaa</em>', $result3);
    }

    public function testHbmHighlightMatchesAdjacentMatches(): void
    {
        $text   = 'foobar';
        $result = MatchesFormatterExtension::apply($text, ['foo', 'bar'], '<span>%s</span>');
        $this->assertSame('<span>foobar</span>', $result);
    }

    public function testHbmHighlightMatchesMultibyteUtf8(): void
    {
        $text   = 'Schöne Grüße über München';
        $result = MatchesFormatterExtension::apply($text, ['schöne', 'grüße', 'münchen'], '<u>%s</u>');
        $this->assertSame('<u>Schöne</u> <u>Grüße</u> über <u>München</u>', $result);
    }

    public function testHbmHighlightMatchesNoMatchFound(): void
    {
        $text   = 'Hello World';
        $result = MatchesFormatterExtension::apply($text, ['xyz', 'abc'], '<span class="foobar">%s</span>');
        $this->assertSame('Hello World', $result);
    }

    public function testHbmHighlightMatchesEmptyOrNullItemsInMatches(): void
    {
        $text   = 'Hello World';
        $result = MatchesFormatterExtension::apply($text, ['', null, 'World'], '<s>%s</s>');
        $this->assertSame('Hello <s>World</s>', $result);
    }

    public function testHbmHighlightMatchesDefaultFormat(): void
    {
        $text   = 'Syndication Name';
        $result = MatchesFormatterExtension::apply($text, ['Syndication']);
        $this->assertSame('<b>Syndication</b> Name', $result);
    }
}
