import './bootstrap'
import './alpine'
import React from 'react'
import ReactDOM from 'react-dom/client';
import CalendarApp from './components/CalendarApp'
import StudentCalendar from './components/StudentCalendar';
import TeacherCalendar from './components/TeacherCaledar';

const moderatorRoot = document.getElementById('moderator-root');
if (moderatorRoot) {
    ReactDOM.createRoot(moderatorRoot).render(
        <React.StrictMode>
            <CalendarApp />
        </React.StrictMode>
    );
}

const studentRoot = document.getElementById('student-root');
if (studentRoot) {
    ReactDOM.createRoot(studentRoot).render(
        <React.StrictMode>
            <StudentCalendar />
        </React.StrictMode>
    );
}

const teacherRoot = document.getElementById('teacher-root');
if (teacherRoot) {
    ReactDOM.createRoot(teacherRoot).render(
        <React.StrictMode>
            <TeacherCalendar />
        </React.StrictMode>
    );
}