import './bootstrap';
import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import Calendar from './components/Calendar';
import Alpine from 'alpinejs';
import { createRoot } from 'react-dom/client';
import CalendarApp from './components/CalendarApp';


const el = document.getElementById('calendar-root');
if (el) {
    createRoot(el).render(<Calendar />);
}
const container = document.getElementById('calendar-root');
if (container) {
    createRoot(container).render(<CalendarApp />);
}s

window.Alpine = Alpine;

Alpine.start();
