import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import timeGridPlugin from '@fullcalendar/timegrid';
import axios from 'axios';

const TeacherCalendar = () => {
    const [events, setEvents] = useState([]);
    const [selectedLesson, setSelectedLesson] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);

    // Pobieranie zajęć z bazy
    const fetchLessons = async () => {
        try {
            const response = await axios.get('/api/lessons');
            const formatted = response.data.map(lesson => ({
                id: lesson.id,
                title: `${lesson.subject?.name} [${lesson.class_group?.name}]`,
                start: lesson.start,
                end: lesson.end,
                extendedProps: {
                    lecturer: lesson.teacher?.name,
                    subjectCode: lesson.subject?.code,
                    groupName: lesson.class_group?.name
                }
            }));
            setEvents(formatted);
        } catch (err) {
            console.error("Błąd pobierania planu:", err);
        }
    };

    useEffect(() => {
        fetchLessons();
    }, []);

    const handleEventClick = (info) => {
        setSelectedLesson({
            id: info.event.id,
            title: info.event.title,
            start: info.event.start,
            end: info.event.end,
            ...info.event.extendedProps
        });
        setIsModalOpen(true);
    };

    return (
        <div className="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
            <FullCalendar
                plugins={[timeGridPlugin]}
                initialView="timeGridWeek"
                events={events}
                eventClick={handleEventClick}
                slotMinTime="08:00:00"
                slotMaxTime="20:00:00"
                allDaySlot={false}
                locale="pl"
                eventTimeFormat={{
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false,
                hour12: false
                }}
                headerToolbar={{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                }}
                editable={false}
                selectable={false}
                eventColor="#3b82f6"
            />

            {isModalOpen && selectedLesson && (
                <div className="fixed inset-0 z-[9999] flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onClick={() => setIsModalOpen(false)}></div>
                    
                    <div className="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                        <div className="bg-blue-600 px-6 py-4 text-white">
                            <h3 className="text-lg font-bold">Szczegóły zajęć</h3>
                            <p className="text-blue-100 text-xs uppercase tracking-wider">{selectedLesson.subjectCode}</p>
                        </div>

                        <div className="p-6 space-y-4">
                            <div>
                                <label className="text-xs font-semibold text-gray-400 uppercase">Przedmiot</label>
                                <p className="text-gray-800 font-medium">{selectedLesson.title.split(' [')[0]}</p>
                            </div>

                            <div className="flex justify-between border-t border-gray-50 pt-3">
                                <div>
                                    <label className="text-xs font-semibold text-gray-400 uppercase">Prowadzący</label>
                                    <p className="text-gray-700">{selectedLesson.lecturer}</p>
                                </div>
                                <div className="text-right">
                                    <label className="text-xs font-semibold text-gray-400 uppercase">Grupa</label>
                                    <p className="text-gray-700">{selectedLesson.groupName}</p>
                                </div>
                            </div>

                            <div className="bg-gray-50 p-3 rounded-lg flex items-center gap-3">
                                <div className="bg-white p-2 rounded shadow-sm text-blue-600">
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p className="text-sm font-bold text-gray-700">
                                        {selectedLesson.start.toLocaleTimeString('pl-PL', {hour: '2-digit', minute:'2-digit'})} - {selectedLesson.end.toLocaleTimeString('pl-PL', {hour: '2-digit', minute:'2-digit'})}
                                    </p>
                                    <p className="text-xs text-gray-500">
                                        {selectedLesson.start.toLocaleDateString('pl-PL', {weekday: 'long', day: 'numeric', month: 'long'})}
                                    </p>
                                </div>
                            </div>
                        </div>

                                                        
                           
                        <div className="px-6 py-4 bg-gray-50 flex flex-col gap-2">
                            <a 
                                href={`/lessons/${selectedLesson.id}/frekwencja`} 
                                className="w-full text-center py-2 bg-indigo-600 border border-transparent text-white font-semibold rounded-xl hover:bg-indigo-700 transition"
                            >
                                Sprawdź obecność
                            </a>
                            <button
                                onClick={() => setIsModalOpen(false)}
                                className="w-full py-2 bg-white border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-100 transition"
                            >
                                Zamknij podgląd
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default TeacherCalendar;