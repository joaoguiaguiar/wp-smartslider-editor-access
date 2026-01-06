# 🛡️ Plugin: Institutional Editor 

## 🎯 Problema Identificado
Em portais institucionais de larga escala, é comum que usuários com perfil de **Editor** precisem gerenciar banners (Smart Slider 3), menus e widgets. Entretanto, por padrão, o WordPress não concede essas permissões ao Editor ou, quando concede, expõe áreas sensíveis do painel que podem comprometer a segurança ou a integridade do layout.

## 🛠️ Solução Desenvolvida
Desenvolvi este plugin que implementa uma camada de **Hardening (Endurecimento)** no painel administrativo, criando um ambiente de trabalho focado e seguro para o editor.

### Diferenciais Técnicos:
- **RBAC Customization:** Modifica dinamicamente as capacidades (*capabilities*) do papel de Editor, injetando permissões específicas para o ecossistema do Smart Slider 3.
- **UI Menu Filtering:** Utiliza hooks globais para remover menus e submenus do painel, deixando apenas o necessário para a operação.
- **Security Audit Trail:** Sistema de log nativo que registra tentativas de acesso a páginas bloqueadas (como plugins ou configurações gerais) e log de IPs.
- **Granular Access Control:** Bloqueia o acesso ao Customizer e ao editor de temas, impedindo alterações acidentais no CSS ou PHP do site.

## ✅ Benefícios
- **Operação Focada:** O Editor visualiza apenas o que precisa gerenciar, aumentando a produtividade.
- **Segurança Proativa:** Bloqueia ataques de escalonamento de privilégios ou acessos indevidos via URL direta.
- **Auditoria:** Registro de logs que auxiliam na governança do portal.

## ⚠️ Transparência e Portfólio
- **Propósito:** Demonstração técnica de segurança e gestão de permissões em WordPress.
- **Refatoração:** Código adaptado para uso seguro e genérico, removendo informações sensíveis.
- **Propriedade:** Lógica e ativos originais pertencem à instituição.
- **Restrições:** Proibida comercialização ou redistribuição do código por terceiros
