# Institutional Editor Hardening

Camada programática de controle de permissões para permitir que o papel **Editor** acesse exclusivamente o plugin **Smart Slider** no ambiente administrativo do WordPress.

## Objetivo

Conceder acesso controlado ao **Smart Slider** para usuários com papel **Editor**, sem ampliar privilégios administrativos além do necessário.

## Implementação

- Interceptação de capacidades via hook `user_has_cap`
- Liberação específica das capacidades exigidas pelo Smart Slider
- Manutenção do isolamento das demais áreas administrativas

## Contexto de Uso

Aplicado em portais institucionais onde o perfil **Editor** precisa gerenciar sliders institucionais, mas não deve possuir permissões administrativas completas.

## Escopo

Este módulo é dedicado exclusivamente à liberação controlada do plugin Smart Slider para o papel Editor.