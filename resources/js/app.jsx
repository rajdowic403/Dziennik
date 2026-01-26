import './bootstrap'
import './alpine'   // 👈 WAŻNE
import React from 'react'
import { createRoot } from 'react-dom/client'
import CalendarApp from './components/CalendarApp'

const container = document.getElementById('calendar-root')
if (container) {
    createRoot(container).render(<CalendarApp />)
}
