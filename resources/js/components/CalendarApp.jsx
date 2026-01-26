import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';
import { createPortal } from 'react-dom';

const CalendarApp = () => {
 
    const [teachers, setTeachers] = useState([]);
    const [subjects, setSubjects] = useState([]);
    const [groups, setGroups] = useState([]);
    const [events, setEvents] = useState([]);
    
   
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [formData, setFormData] = useState({
        subject_id: '',
        teacher_id: '',
        class_group_id: '',
        start: '',
        end: ''
    });

    const fetchEvents = async () => {
    try {
        const response = await axios.get('/api/lessons');
        const formattedEvents = response.data.map(lesson => ({
            id: lesson.id,
            title: `${lesson.subject.name} - ${lesson.teacher.name}`,
            start: lesson.start,
            end: lesson.end,
            extendedProps: {
                group: lesson.class_group.name
            }
        }));
        setEvents(formattedEvents);
    } catch (err) {
        console.error("Błąd ładowania lekcji:", err);
    }
};
    
    useEffect(() => {
        const fetchData = async () => {
            try {
                const [tRes, sRes, gRes] = await Promise.all([
                    axios.get('/api/teachers'),
                    axios.get('/api/subjects'),
                    axios.get('/api/groups')
                ]);
                setTeachers(tRes.data);
                setSubjects(sRes.data);
                setGroups(gRes.data);
                await fetchEvents();
            } catch (err) {
                console.error("Błąd pobierania słowników:", err);
            }
        };
        fetchData();
    }, []);

    
    const handleSelect = (info) => {
        setFormData({
            ...formData,
            start: info.startStr,
            end: info.endStr
        });
        setIsModalOpen(true);
    };

   const LessonModal = ({ onClose }) => {
    return createPortal(
        <div className="fixed inset-0 z-[1000] flex items-center justify-center ">
            
            <div
                className="absolute inset-0 z-[1000]  bg-black/40"
                onClick={onClose}
            />
            <div className="relative w-[420px] max-w-[90vw] bg-white rounded-xl shadow-2xl z-[10000]">
                
                <div className="flex items-start justify-between p-5 border-b bg-gray-50">
                    <h3 className="text-xl font-semibold">
                        Zaplanuj zajęcia akademickie
                    </h3>
                    <button onClick={onClose} className="text-3xl leading-none">
                        ×
                    </button>
                </div>

                <div className="p-6 space-y-4">
                    <div className="bg-blue-50 p-4 rounded text-sm border">
                        <p><strong>Początek:</strong> {new Date(formData.start).toLocaleString('pl-PL')}</p>
                        <p><strong>Koniec:</strong> {new Date(formData.end).toLocaleString('pl-PL')}</p>
                    </div>

                    <select
                        className="w-full p-2 border rounded"
                        onChange={e => setFormData({ ...formData, subject_id: e.target.value })}
                    >
                        <option value="">Wybierz przedmiot</option>
                        {subjects.map(s => (
                            <option key={s.id} value={s.id}>{s.name}</option>
                        ))}
                    </select>

                    <select
                        className="w-full p-2 border rounded"
                        onChange={e => setFormData({ ...formData, teacher_id: e.target.value })}
                    >
                        <option value="">Wybierz prowadzącego</option>
                        {teachers.map(t => (
                            <option key={t.id} value={t.id}>{t.name}</option>
                        ))}
                    </select>

                    <select
                        className="w-full p-2 border rounded"
                        onChange={e => setFormData({ ...formData, class_group_id: e.target.value })}
                    >
                        <option value="">Wybierz grupę</option>
                        {groups.map(g => (
                            <option key={g.id} value={g.id}>{g.name}</option>
                        ))}
                    </select>
                </div>

                <div className="flex justify-end gap-3 p-5 border-t">
                    <button onClick={onClose} className="text-gray-500">
                        Anuluj
                    </button>
                    <button
                        onClick={saveLesson}
                        className="bg-blue-600 text-white px-5 py-2 rounded"
                    >
                        Zatwierdź
                    </button>
                </div>
            </div>
        </div>,
        document.body
    );
};


    const saveLesson = async () => {
        try {
            const response = await axios.post('/api/lessons', formData);
            alert("Zajęcia zapisane pomyślnie!");
            setIsModalOpen(false);
        window.location.reload()
        } catch (err) {
            console.error(err);
            alert("Błąd: " + (err.response?.data?.message || "Nie udało się zapisać zajęć"));
        }
    };

    return (
    <>
        <div className="calendar-container bg-white p-4 shadow-lg rounded-lg">
            <FullCalendar
                plugins={[timeGridPlugin, interactionPlugin]}
                initialView="timeGridWeek"
                selectable
                select={handleSelect}
                slotMinTime="08:00:00"
                slotMaxTime="21:00:00"
                allDaySlot={false}
                locale="pl"
                events={events}
                headerToolbar={{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                }}
            />
        </div>

        {isModalOpen && (
            <LessonModal onClose={() => setIsModalOpen(false)} />
        )}
    </>
);
};

export default CalendarApp;