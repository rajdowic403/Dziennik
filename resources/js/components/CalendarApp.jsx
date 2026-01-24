import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from "@fullcalendar/interaction";
import axios from 'axios';

const CalendarApp = () => {
    const [events, setEvents] = useState([]);

    useEffect(() => {
        fetchEvents();
    }, []);

    const fetchEvents = () => {
        axios.get('/api/events').then(res => setEvents(res.data));
    };

    const handleSelect = (info) => {
        const title = prompt("Nazwa wydarzenia:");
        if (title) {
            axios.post('/api/events', {
                title,
                start: info.startStr,
                end: info.endStr
            }).then(() => fetchEvents());
        }
    };

    return (
        <FullCalendar
            plugins={[dayGridPlugin, interactionPlugin]}
            initialView="dayGridMonth"
            selectable={true}
            events={events}
            select={handleSelect}
            locale="pl"
        />
    );
};

export default CalendarApp;