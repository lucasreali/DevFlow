/**
 * Sistema de Modo Escuro para o DevFlow
 * 
 * Este script gerencia a funcionalidade de alternância entre os modos claro e escuro.
 * Ele salva a preferência do usuário no localStorage e aplica as classes CSS apropriadas.
 * 
 * Como implementar um novo componente compatível com o modo escuro:
 * 1. Adicione variáveis CSS no arquivo style.css para o elemento
 * 2. Use as variáveis CSS em vez de cores fixas
 * 3. Para elementos que precisam de inversão no modo escuro, adicione a classe 'invert-in-dark'
 */
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona os elementos DOM necessários
    const themeToggle = document.getElementById('theme-toggle');
    const darkIcon = document.querySelector('.dark-icon');
    const lightIcon = document.querySelector('.light-icon');
    
    // Verifica se há uma preferência salva no localStorage
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    /**
     * Aplica o tema com base na preferência do usuário
     * 
     * @param {boolean} isDark - Se verdadeiro, aplica o modo escuro, caso contrário, modo claro
     */
    function applyTheme(isDark) {
        if (isDark) {
            // Ativa o modo escuro
            document.body.classList.add('dark-mode');
            
            // Alterna os ícones
            darkIcon.style.display = 'none';
            lightIcon.style.display = 'inline-block';
            
            // Altera o logo para versão clara se existir
            if (document.querySelector('.devflow-logo')) {
                const logo = document.querySelector('.devflow-logo');
                if (logo.dataset.lightSrc) {
                    logo.src = logo.dataset.lightSrc;
                }
            }
            
            // Adiciona classe para inverter ícones escuros
            document.querySelectorAll('.invert-in-dark').forEach(icon => {
                icon.classList.add('icon-inverted');
            });
        } else {
            // Desativa o modo escuro
            document.body.classList.remove('dark-mode');
            
            // Alterna os ícones
            darkIcon.style.display = 'inline-block';
            lightIcon.style.display = 'none';
            
            // Volta para o logo normal
            if (document.querySelector('.devflow-logo')) {
                const logo = document.querySelector('.devflow-logo');
                if (logo.dataset.darkSrc) {
                    logo.src = logo.dataset.darkSrc;
                }
            }
            
            // Remove classe de inversão
            document.querySelectorAll('.invert-in-dark').forEach(icon => {
                icon.classList.remove('icon-inverted');
            });
        }
    }
    
    // Aplica o tema inicial baseado na preferência salva
    applyTheme(isDarkMode);
    
    // Configurar o ouvinte de evento para o botão de alternância
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            // Inverte o estado atual
            const isDark = !document.body.classList.contains('dark-mode');
            
            // Aplica o novo tema
            applyTheme(isDark);
            
            // Salva a preferência no localStorage para persistência
            localStorage.setItem('darkMode', isDark);
        });
    }
});
