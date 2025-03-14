<?php

declare(strict_types=1);

namespace Misterioso013\Tools\Tests\ValueObjects;

use InvalidArgumentException;
use Misterioso013\Tools\ValueObjects\Cpf;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
    public function testShouldCreateValidCpf(): void
    {
        $cpfString = '12345678909';
        $cpf = new Cpf($cpfString);

        $this->assertEquals($cpfString, $cpf->getValue());
    }

    public function testShouldThrowExceptionForInvalidCpf(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Cpf('12345678900');
    }

    public function testShouldFormatCpf(): void
    {
        $cpf = new Cpf('12345678909');
        $this->assertEquals('123.456.789-09', $cpf->format());
    }

    public function testShouldGenerateValidCpf(): void
    {
        $cpf = Cpf::generate();
        $this->assertInstanceOf(Cpf::class, $cpf);
    }

    public function testShouldGenerateCpfForSpecificState(): void
    {
        $cpf = Cpf::generate(true, 'SP');
        $this->assertEquals('SP', $cpf->getUF(false)[0]);
    }
}
