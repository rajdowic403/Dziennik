import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import CalendarApp from './components/CalendarApp';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

const container = document.getElementById('calendar-root');
if (container) {
    const root = createRoot(container);
    root.render(<CalendarApp />);
}