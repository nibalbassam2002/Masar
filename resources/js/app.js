import './bootstrap';

// نظام التحكم في النوافذ المنبثقة (Modals) العالمي لمسار
window.toggleModal = function(modalId, show = true) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const container = modal.querySelector('.relative');

    if (show) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    } else {
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
}