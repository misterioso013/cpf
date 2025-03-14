# Gerador e validador de CPF 🇧🇷

![CI Status](https://github.com/misterioso013/cpf/workflows/CI/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/misterioso013/cpf/v)](https://packagist.org/packages/misterioso013/cpf)
[![License](https://poser.pugx.org/misterioso013/cpf/license)](https://packagist.org/packages/misterioso013/cpf)

Biblioteca PHP moderna para geração e validação de CPFs.

### Requisitos 📋

- PHP 8.1 ou superior
- Composer

## Instalação 💿

```bash
composer require misterioso013/cpf
```

## Uso 🚀

### Usando Value Object (Recomendado)

```php
use Misterioso013\Tools\ValueObjects\Cpf;

// Criar um CPF a partir de uma string
$cpf = new Cpf('12345678909');

// Formatar CPF
echo $cpf->format(); // 123.456.789-09

// Gerar CPF aleatório
$cpf = Cpf::generate(); // Com máscara por padrão
$cpf = Cpf::generate(false); // Sem máscara

// Gerar CPF para um estado específico
$cpf = Cpf::generate(true, 'SP');

// Verificar UF do CPF
echo $cpf->getUF(); // Retorna string (ex: "SP")
$ufs = $cpf->getUF(false); // Retorna array
```

### Usando API Legacy

```php
use Misterioso013\Tools\CPF;

// Gerar CPF válido formatado (123.456.789-10)
echo CPF::cpfRandom();

// Gerar CPF válido sem máscara (12345678910)
echo CPF::cpfRandom(false);

// Verificar se CPF é válido
var_dump(CPF::validateCPF('12345678910'));

// Verificar UF do CPF
print_r(CPF::whichUF('12345678910', false));
```

## Testes 🧪

```bash
composer test
```

## Contribuindo 🤝

Contribuições são bem-vindas! Por favor, leia as [diretrizes de contribuição](CONTRIBUTING.md) antes de enviar um PR.

## Licença 📄

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.
