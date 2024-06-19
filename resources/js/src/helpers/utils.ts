import { showError } from "./toastNotification";

export function showErrorResponse(error: unknown) {
    if (Array.isArray(error)) {
        for (const message of error as string[]) {
            showError(message);
        }
    } else {
        showError((error as Error).message);
    }
}

export function myDebounce<T>(func: () => Promise<T>, delay: number) {
    let timer: any;
    return function () {
        clearTimeout(timer);
        setTimeout(() => func(), delay);
    }
}

export function openModal(element: string) {
    return new Promise((resolve) => {
        // Abrir el modal de Tailwind usando its API
        var modal = document.getElementById(element) as HTMLElement;

        if (modal) {
            setTimeout(() => {
                modal.classList.add('fade', 'show');
                modal.style.display = 'block';
                modal.classList.add('in');    
            }, 500);
            
            // Add class to the body for the modal backdrop
            document.body.classList.add('modal-open');
            
            var modalBackdrop = document.createElement('div');
            modalBackdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(modalBackdrop);
        }

        resolve(modal);
    });
}

export function closeModal(element: string) {
    // Close the Tailwind modal
    var modal = document.getElementById(element) as HTMLElement;
    var modalBackdrop = document.querySelector('.modal-backdrop');

    if (modal) {
        // Remove added classes
        modal.classList.remove('fade', 'show', 'in');
        modal.style.display = 'none';

        document.body.classList.remove('modal-open');

        // Remove the modal backdrop element
        if (modalBackdrop) {
            document.body.removeChild(modalBackdrop);
        }
    }
}

export function getChar(str: string) {
    if (typeof str !== 'undefined') {
        const index = 1;
        if (index >= 0 && index < str.length) {
            return str.charAt(index).toLocaleUpperCase();
        } else {
            return '';
        }
    }
}