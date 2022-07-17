# Gerador e validador de CPF

Esse é um simples gerador e validador de CPFs para te ajudar em suas aplicações PHP.

### Requisitos

- PHP 7 ou superior
- Composer (Recomendado)

## Instalação

Instalação simples com composer: `composer require misterioso013/cpf`

**OBS:** Composer não é obrigatório

```php
<?php
// Instalação simples
// require 'src/CPF.php';

// Instalação com composer
require __DIR__. '/vendor/autoload.php';

use Misterioso013\Tools\CPF;

// Gerar um CPF válidos aleatórios formatados (123.456.789-10)
echo CPF::cpfRandom()."\n";

// Gerar um CPF válidos aleatórios sem máscara (12345678910)
echo CPF::cpfRandom(false)."\n";

// Verificar se o CPF é válido retorna true ou false
var_dump(CPF::validateCPF('12345678910'));

// Verificar em qual(is) UF(s) o CPF foi emitido
print_r(CPF::whichUF(12345678910, false));

// Exemplo de uso
$cpf = CPF::cpfRandom();
echo CPF::validateCPF($cpf) ? "O CPF: $cpf é válido e só pode ter sido emitido  na(s) UF(s): ".CPF::whichUF($cpf) : "$cpf não é um CPF válido!";
```

Esse projeto é bem simples e leve, pode ser usado em qualquer aplicação PHP independente do seu tamanho.

Pretendo desenvolver mais projetos como esse em breve, se você tiver alguma ideia de algo legal que possa ser feito, por
favor, deixe-me saber [aqui](https://github.com/misterioso013#conecte-se-comigo).
