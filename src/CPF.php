<?php

declare(strict_types=1);

namespace Misterioso013\Tools;

use function count;
use function floor;
use function in_array;
use function round;
use function substr;
use InvalidArgumentException;

class CPF
{
    private const INVALID_SEQUENCES = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999'
    ];

    /** @var array<int, array<int, string>> */
    private static array $estados = [
        ['RS'],
        ['DF', 'GO', 'MT', 'MS', 'TO'],
        ['AM', 'PA', 'RR', 'AP', 'AC', 'RO'],
        ['CE', 'MA', 'PI'],
        ['PB', 'PE', 'AL', 'RN'],
        ['BA', 'SE'],
        ['MG'],
        ['RJ', 'ES'],
        ['SP'],
        ['PR', 'SC']
    ];

    /**
     * Valida o CPF, retorna true em caso de sucesso e false no caso do CPF não está correto
     * @param string|null $cpf
     * @return boolean
     */
    public static function validateCPF(?string $cpf = null): bool
    {
        if (empty($cpf)) {
            return false;
        }

        $cpf = (string) preg_replace("/\D/", "", $cpf);

        if (strlen($cpf) !== 11 || in_array($cpf, self::INVALID_SEQUENCES, true)) {
            return false;
        }

        return self::validateDigits($cpf);
    }

    private static function validateDigits(string $cpf): bool
    {
        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($c = 0; $c < $t; $c++) {
                $sum += (int)$cpf[$c] * (($t + 1) - $c);
            }
            $digit = ((10 * $sum) % 11) % 10;
            if ((int)$cpf[$t] !== $digit) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gera um CPF válido, com máscara ou não
     * @param bool $mascara
     * @param string $estado
     * @return string
     * @example cpfRandom(false, 'BA')
     */
    public static function cpfRandom(bool $mascara = true, string $estado = 'BR'): string
    {
        $estado = mb_strtoupper($estado);

        for ($i = 0; $i <= 9; $i++) {
            if (in_array($estado, self::$estados[$i])) {
                $n9 = $i;
                break;
            }
        }

        if (empty($n9)) {
            $n9 = rand(0, 9);
        }

        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - (self::mod($d1));
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - (self::mod($d2));
        if ($d2 >= 10) {
            $d2 = 0;
        }
        $retorno = '';
        if ($mascara == 1) {
            $retorno = '' . $n1 . $n2 . $n3 . "." . $n4 . $n5 . $n6 . "." . $n7 . $n8 . $n9 . "-" . $d1 . $d2;
        } else {
            $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
        }
        return $retorno;
    }

    /**
     * @param $dividendo
     * @return float
     */
    private static function mod(float|int $dividendo): float
    {
        return round($dividendo - (floor($dividendo / 11) * 11));
    }

    /**
     * Diz em qual(is) UF(s) o CPF pode ter sido emitido, caso não seja possível retorna false
     * @param string $cpf
     * @param bool $inText
     * @return array<int, string>|string|false
     */
    public static function whichUF(string $cpf, bool $inText = true): array|string|false
    {
        if (!is_string($cpf) || (strlen($cpf) !== 11 && strlen($cpf) !== 14)) {
            return false;
        }

        // Remove pontos e traços
        if (strlen($cpf) === 14) {
            $cpf = (string) preg_replace("/\D/", "", $cpf);
            if (strlen($cpf) !== 11) {
                return false;
            }
        }

        // Se não for um valor numérico
        if (!is_numeric($cpf)) {
            return false;
        }

        // Pega o nono dígito
        $digito = (int)substr($cpf, 8, 1);

        $estados = self::$estados[$digito];

        // Se não quiser os estados em formato de texto, retorna o array
        if (!$inText) {
            /** @var array<int, string> $estados */
            return $estados;
        }

        // Transforma o array em texto
        $text = '';
        for ($i = 0; $i < count($estados); $i++) {
            if ($i != 0 && $i + 1 === count($estados)) {
                $text .= ' ou ';
            }

            $text .= $estados[$i];

            if ($i + 3 <= count($estados)) {
                $text .= ', ';
            }
        }

        /** @var string $text */
        return $text;
    }
}
