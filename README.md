# 🛡️ Plugin: Institutional Editor 

## 🎯 Problema Identificado
Em ambientes WordPress institucionais, frequentemente é necessário conceder acesso granular a usuários com perfil de **Editor** para gerenciamento específico de plugins (como Smart Slider 3), menus e widgets, sem expor áreas sensíveis do painel administrativo.

## 🛠️ Solução Desenvolvida
Desenvolvi este plugin que implementa uma camada de **Hardening (Endurecimento)** no painel administrativo, criando um ambiente de trabalho focado e seguro através de controle preciso de permissões.

### Diferenciais Técnicos:
- **RBAC Customization:** Modifica dinamicamente as capacidades (*capabilities*) do papel de Editor, injetando permissões específicas para o ecossistema do Smart Slider 3.
- **UI Menu Filtering:** Utiliza hooks globais para remover menus e submenus do painel, deixando apenas o necessário para a operação.
- **Security Audit Trail:** Sistema de log nativo que registra tentativas de acesso a páginas bloqueadas (como plugins ou configurações gerais) e log de IPs.
- **Granular Access Control:** Bloqueia o acesso ao Customizer e ao editor de temas, impedindo alterações acidentais no CSS ou PHP do site.

## ⚠️ Transparência e Portfólio
- **Propósito:** Demonstração técnica de segurança e gestão de permissões em WordPress.
- **Refatoração:** Código adaptado para uso seguro e genérico, removendo informações sensíveis.
- **Propriedade:** Lógica e ativos originais pertencem à instituição.
- **Restrições:** Proibida comercialização ou redistribuição do código por terceiros
