// Evento personalizado para el tema oscuro
window.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        dark: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('darkMode', this.dark);
            document.documentElement.classList.toggle('dark', this.dark);
        }
    });

    // Componente para el menú de notificaciones
    Alpine.data('notifications', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        }
    }));

    // Componente para el menú de perfil
    Alpine.data('profileMenu', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        }
    }));
});

// Inicializar el tema al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const darkMode = localStorage.getItem('darkMode') === 'true';
    document.documentElement.classList.toggle('dark', darkMode);
});

document.addEventListener('alpine:init', () => {
    Alpine.data('data', () => ({
        dark: localStorage.getItem('darkMode') === 'true',
        isSideMenuOpen: false,
        currentSideMenuTab: null,
        isSubHeaderOpen: false,
        watchScreen() {
            if (window.innerWidth <= 1024) {
                this.isSideMenuOpen = false
            }
        },
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },
        toggleTheme() {
            this.dark = !this.dark;
            localStorage.setItem('darkMode', this.dark);
            document.documentElement.classList.toggle('dark', this.dark);
        }
    }));

    // Inicializar el tema al cargar la página
    const darkMode = localStorage.getItem('darkMode') === 'true';
    document.documentElement.classList.toggle('dark', darkMode);
});

function data() {
    function getThemeFromLocalStorage() {
        // if user already changed the theme, use it
        if (window.localStorage.getItem("dark")) {
            return JSON.parse(window.localStorage.getItem("dark"));
        }

        // else return their preferences
        return (
            !!window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        );
    }

    function setThemeToLocalStorage(value) {
        window.localStorage.setItem("dark", value);
    }

    return {
        dark: getThemeFromLocalStorage(),
        toggleTheme() {
            this.dark = !this.dark;
            setThemeToLocalStorage(this.dark);
        },
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen;
        },
        closeSideMenu() {
            this.isSideMenuOpen = false;
        },
        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false;
        },
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen;
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false;
        },
        isPagesMenuOpen: false,
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen;
        },
        // Modal
        // isModalOpen: false,
        // trapCleanup: null,
        // openModal() {
        //     this.isModalOpen = true;
        //     this.trapCleanup = focusTrap(document.querySelector("#modal"));
        // },
        // closeModal() {
        //     this.isModalOpen = false;
        //     this.trapCleanup();
        // },
        data() {
            return {
                isPostsMenuOpen: null,
            };
        },
        togglePostsMenu(postId) {
            if (this.isPostsMenuOpen === postId) {
                this.isPostsMenuOpen = null; // Close the menu if it's already open
            } else {
                this.isPostsMenuOpen = postId; // Open the menu associated with the clicked post
            }
        },
        closePostsMenu(postId) {
            if (this.isPostsMenuOpen === postId) {
                this.isPostsMenuOpen = null; // Close the menu
            }
        },
    };
}
