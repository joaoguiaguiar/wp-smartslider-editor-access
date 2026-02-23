# Institutional Editor Hardening

Camada de controle programático de permissões (RBAC) e hardening administrativo para WordPress em ambientes institucionais.

## Objetivo

Restringir o papel Editor a um conjunto específico de funcionalidades, mantendo isolamento de áreas administrativas sensíveis.

## Principais Recursos

- Controle fino de acesso via `user_has_cap`
- Remoção estratégica de menus e submenus administrativos
- Bloqueio de acesso direto a páginas sensíveis via URL
- Hardening da barra administrativa e do Customizer
- Registro de tentativas de acesso não autorizado
- Liberação controlada para plugins específicos (ex: Smart Slider)
- Estrutura modular e reutilizável para outros portais

## Contexto de Uso

Aplicado em portais institucionais que exigem restrição de acesso administrativo e manutenção segura do WordPress.

## Nota

Exemplo de uso com Smart Slider, mas a arquitetura permite expansão para outros plugins e funcionalidades.