<?php

declare(strict_types=1);

namespace Misterioso013\Tools\ValueObjects;

use InvalidArgumentException;
use Misterioso013\Tools\CPF as LegacyCPF;

final class Cpf
{
    private string $value;

    public function __construct(string $cpf)
    {
        $this->setValue($cpf);
    }

    private function setValue(string $cpf): void
    {
        $cpf = (string) preg_replace("/\D/", "", $cpf);

        if (!$this->isValid($cpf)) {
            throw new InvalidArgumentException('CPF inválido');
        }

        $this->value = $cpf;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function format(): string
    {
        return substr($this->value, 0, 3) . '.' .
            substr($this->value, 3, 3) . '.' .
            substr($this->value, 6, 3) . '-' .
            substr($this->value, 9, 2);
    }

    /**
     * @return array<int, string>|string
     * @throws InvalidArgumentException
     */
    public function getUF(bool $inText = true): array|string
    {
        $result = LegacyCPF::whichUF($this->value, $inText);
        if ($result === false) {
            throw new InvalidArgumentException('CPF inválido');
        }
        /** @var array<int, string>|string $result */
        return $result;
    }

    private function isValid(string $cpf): bool
    {
        return LegacyCPF::validateCPF($cpf);
    }

    public static function generate(bool $formatted = true, string $estado = 'BR'): self
    {
        $cpf = LegacyCPF::cpfRandom(!$formatted, $estado);
        return new self($cpf);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    // ... outros métodos
}
