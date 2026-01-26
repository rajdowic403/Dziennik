import './bootstrap'
import './alpine'   // 👈 WAŻNE
import React from 'react'
import { createRoot } from 'react-dom/client'
import CalendarApp from './components/CalendarApp'
import StudentCalendar from './components/StudentCalendar';

const modRoot = document.getElementById('moderator-root');
if (modRoot) {
    ReactDOM.createRoot(modRoot).render(<CalendarApp />);
}
const studentRoot = document.getElementById('student-root');
if (studentRoot) {
    ReactDOM.createRoot(studentRoot).render(<StudentCalendar />);
}