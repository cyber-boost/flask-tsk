<?php
/**
 * language-selector.php
 * Enhanced language selector with flags and smooth transitions
 */
?>

<section class="tusk-utility-language-selector" id="language">
    <div class="utility-container">
        <h2>🌍 Language Selector</h2>
        <p>Choose your preferred language for the best experience</p>
        
        <div class="language-selector">
            <button class="language-current" id="current-language">
                <span class="flag">🇺🇸</span>
                <span class="language-name">English</span>
                <span class="dropdown-arrow">▼</span>
            </button>
            
            <div class="language-dropdown" id="language-dropdown">
                <div class="language-option" data-lang="en" data-flag="🇺🇸">
                    <span class="flag">🇺🇸</span>
                    <span class="language-name">English</span>
                    <span class="language-native">English</span>
                </div>
                <div class="language-option" data-lang="es" data-flag="🇪🇸">
                    <span class="flag">🇪🇸</span>
                    <span class="language-name">Spanish</span>
                    <span class="language-native">Español</span>
                </div>
                <div class="language-option" data-lang="fr" data-flag="🇫🇷">
                    <span class="flag">🇫🇷</span>
                    <span class="language-name">French</span>
                    <span class="language-native">Français</span>
                </div>
                <div class="language-option" data-lang="de" data-flag="🇩🇪">
                    <span class="flag">🇩🇪</span>
                    <span class="language-name">German</span>
                    <span class="language-native">Deutsch</span>
                </div>
                <div class="language-option" data-lang="it" data-flag="🇮🇹">
                    <span class="flag">🇮🇹</span>
                    <span class="language-name">Italian</span>
                    <span class="language-native">Italiano</span>
                </div>
                <div class="language-option" data-lang="ja" data-flag="🇯🇵">
                    <span class="flag">🇯🇵</span>
                    <span class="language-name">Japanese</span>
                    <span class="language-native">日本語</span>
                </div>
                <div class="language-option" data-lang="zh" data-flag="🇨🇳">
                    <span class="flag">🇨🇳</span>
                    <span class="language-name">Chinese</span>
                    <span class="language-native">中文</span>
                </div>
            </div>
        </div>
        
        <div class="language-demo" id="language-demo">
            <h3 id="demo-title">Welcome to TuskPHP</h3>
            <p id="demo-text">This text will change based on your language selection.</p>
        </div>
    </div>
</section>

<script>
const translations = {
    en: {
        title: "Welcome to TuskPHP",
        text: "This text will change based on your language selection."
    },
    es: {
        title: "Bienvenido a TuskPHP",
        text: "Este texto cambiará según tu selección de idioma."
    },
    fr: {
        title: "Bienvenue sur TuskPHP",
        text: "Ce texte changera en fonction de votre sélection de langue."
    },
    de: {
        title: "Willkommen bei TuskPHP",
        text: "Dieser Text ändert sich je nach Ihrer Sprachauswahl."
    },
    it: {
        title: "Benvenuto in TuskPHP",
        text: "Questo testo cambierà in base alla selezione della lingua."
    },
    ja: {
        title: "TuskPHPへようこそ",
        text: "このテキストは言語選択に基づいて変更されます。"
    },
    zh: {
        title: "欢迎使用TuskPHP",
        text: "此文本将根据您的语言选择而更改。"
    }
};

document.getElementById('current-language').addEventListener('click', function() {
    const dropdown = document.getElementById('language-dropdown');
    dropdown.classList.toggle('show');
});

document.querySelectorAll('.language-option').forEach(option => {
    option.addEventListener('click', function() {
        const lang = this.getAttribute('data-lang');
        const flag = this.getAttribute('data-flag');
        const name = this.querySelector('.language-name').textContent;
        
        // Update current language button
        const currentBtn = document.getElementById('current-language');
        currentBtn.querySelector('.flag').textContent = flag;
        currentBtn.querySelector('.language-name').textContent = name;
        
        // Update demo content
        updateLanguageDemo(lang);
        
        // Close dropdown
        document.getElementById('language-dropdown').classList.remove('show');
        
        // Store selection
        localStorage.setItem('selectedLanguage', lang);
        
        // Show success message
        showLanguageChangeNotification(name);
    });
});

function updateLanguageDemo(lang) {
    const title = document.getElementById('demo-title');
    const text = document.getElementById('demo-text');
    
    // Fade out
    title.style.opacity = '0';
    text.style.opacity = '0';
    
    setTimeout(() => {
        title.textContent = translations[lang].title;
        text.textContent = translations[lang].text;
        
        // Fade in
        title.style.opacity = '1';
        text.style.opacity = '1';
    }, 200);
}

function showLanguageChangeNotification(languageName) {
    const notification = document.createElement('div');
    notification.className = 'language-notification';
    notification.innerHTML = `
        <div class="notification-content">
            ✅ Language changed to ${languageName}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.language-selector')) {
        document.getElementById('language-dropdown').classList.remove('show');
    }
});

// Load saved language on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedLang = localStorage.getItem('selectedLanguage');
    if (savedLang && translations[savedLang]) {
        const option = document.querySelector(`[data-lang="${savedLang}"]`);
        if (option) {
            option.click();
        }
    }
});
</script>