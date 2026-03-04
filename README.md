# Institutional Editor Hardening

Camada programática de controle de permissões do perfil **Editor** no ambiente administrativo do WordPress.

## Objetivo

Conceder acesso controlado ao **Smart Slider** para usuários com papel **Editor**, mantendo o isolamento das demais áreas administrativas por segurança.

## Implementação

- Interceptação de capacidades via hook `user_has_cap`
- Liberação específica das capacidades exigidas pelo Smart Slider
- Remoção de itens do menu lateral não autorizados para o Editor
- Bloqueio de acesso via URL direta a páginas sensíveis (`users.php`, `options-general.php`, etc.)
- Bloqueio do Personalizador de temas para não-administradores
- Limpeza da barra de administração (remoção de updates, comments, customize)
- Registro de auditoria em `error_log` para logins e tentativas de acesso bloqueadas
- Hooks de ativação e desativação para gerenciamento limpo das capacidades
- UI de monitoramento de status do plugin disponível para administradores em **Ferramentas > Access Status**

## Contexto de Uso

Aplicado em portais institucionais onde o perfil **Editor** precisa gerenciar sliders institucionais, mas não deve possuir permissões administrativas completas.

## Escopo

Este módulo controla o acesso do perfil **Editor**, concedendo navegação ao Dashboard, Posts, Páginas, Biblioteca de Mídia, **Smart Slider** e os submenus de Menus e Widgets dentro de Aparência.
