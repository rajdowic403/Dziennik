import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const CalendarApp = () => {
    const [teachers, setTeachers] = useState([]);
    const [subjects, setSubjects] = useState([]);
    const [groups, setGroups] = useState([]);
    
    const [events, setEvents] = useState([]);
    const [selectedFilterGroup, setSelectedFilterGroup] = useState('');
    
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [formData, setFormData] = useState({
        subject_id: '',
        teacher_id: '',
        class_group_id: '',
        start: '',
        end: ''
    });

    const [isDetailsModalOpen, setIsDetailsModalOpen] = useState(false);
    const [selectedEvent, setSelectedEvent] = useState(null);

    const fetchLessons = async (groupId = '') => {
        try {
            const url = groupId ? `/api/lessons?group_id=${groupId}` : '/api/lessons';
            const lRes = await axios.get(url);
            
            console.log("Surowe dane z bazy:", lRes.data); 

            const formattedEvents = lRes.data.map(lesson => {
                const safeStart = lesson.start ? lesson.start.replace(' ', 'T') : '';
                const safeEnd = lesson.end ? lesson.end.replace(' ', 'T') : '';

                const groupData = lesson.classGroup || lesson.class_group;

                return {
                    id: lesson.id,
                    title: `${lesson.subject?.name || 'Brak'} - ${groupData?.name || 'Brak'}`,
                    start: safeStart,
                    end: safeEnd,
                    extendedProps: {
                        teacherName: lesson.teacher?.name || 'Nieznany',
                        groupName: groupData?.name || 'Nieznana',
                        subjectName: lesson.subject?.name || 'Nieznany'
                    }
                };
            });
            
            console.log("Lekcje po sformatowaniu (gotowe do kalendarza):", formattedEvents);
            setEvents(formattedEvents);
        } catch (err) {
            console.error("Błąd pobierania danych kalendarza:", err);
        }
    };

    useEffect(() => {
        const fetchDictionaries = async () => {
            try {
                const [tRes, sRes, gRes] = await Promise.all([
                    axios.get('/api/teachers'),
                    axios.get('/api/subjects'),
                    axios.get('/api/groups')
                ]);
                setTeachers(tRes.data);
                setSubjects(sRes.data);
                setGroups(gRes.data);
            } catch (err) {
                console.error("Błąd pobierania słowników:", err);
            }
        };
        fetchDictionaries();
    }, []);

    useEffect(() => {
        fetchLessons(selectedFilterGroup);
    }, [selectedFilterGroup]);

    const handleSelect = (info) => {
        
        setFormData({
            subject_id: '',
            teacher_id: '',
            class_group_id: selectedFilterGroup, 
            start: info.startStr,
            end: info.endStr
        });
        setIsModalOpen(true);
    };

    const handleEventClick = (info) => {
        setSelectedEvent({
            id: info.event.id,
            title: info.event.title,
            start: info.event.start,
            end: info.event.end,
            ...info.event.extendedProps
        });
        setIsDetailsModalOpen(true);
    };

    const saveLesson = async () => {
       
        if (!formData.subject_id || !formData.teacher_id || !formData.class_group_id) {
            alert("Proszę wypełnić wszystkie pola!");
            return;
        }

        try {
            await axios.post('/api/lessons', formData);
            alert("Zajęcia zapisane!");
            setIsModalOpen(false);
            
            fetchLessons(selectedFilterGroup);
        } catch (err) {
            console.error(err);
            alert("Błąd: " + (err.response?.data?.message || "Nie udało się zapisać zajęć"));
        }
    };

    return (
        <div className="calendar-container bg-white p-4 shadow-lg rounded-lg">
            
            <div className="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg flex flex-col sm:flex-row items-center gap-4">
                <label className="font-semibold text-gray-700">Wybierz klasę:</label>
                <select 
                    className="w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value={selectedFilterGroup}
                    onChange={(e) => setSelectedFilterGroup(e.target.value)}
                >
                    <option value="">Wszystkie grupy</option>
                    {groups.map(g => <option key={g.id} value={g.id}>{g.name}</option>)}
                </select>
            </div>

            <FullCalendar
                plugins={[timeGridPlugin, interactionPlugin]}
                initialView="timeGridWeek"
                selectable={true}
                select={handleSelect}
                eventClick={handleEventClick}
                events={events} 
                slotMinTime="08:00:00"
                slotMaxTime="21:00:00"
                allDaySlot={false}
                locale="pl"
                timeZone="local"
                headerToolbar={{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                }}
            />

            {isModalOpen && (
                <div className="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-[1000]">
                    <div className="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md border-t-4 border-blue-600">
                        <h2 className="text-2xl font-bold text-gray-800 mb-4">Zaplanuj zajęcia</h2>
                        <div className="space-y-4">
                            <div className="bg-blue-50 p-3 rounded text-sm text-blue-800">
                                <strong>Termin:</strong> {new Date(formData.start).toLocaleString('pl-PL')} <br/>
                                <strong>Koniec:</strong> {new Date(formData.end).toLocaleString('pl-PL')}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">Przedmiot</label>
                                <select className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" value={formData.subject_id} onChange={e => setFormData({...formData, subject_id: e.target.value})}>
                                    <option value="">Wybierz przedmiot...</option>
                                    {subjects.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
                                </select>
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">Prowadzący</label>
                                <select className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" value={formData.teacher_id} onChange={e => setFormData({...formData, teacher_id: e.target.value})}>
                                    <option value="">Wybierz prowadzącego...</option>
                                    {teachers.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                                </select>
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">Grupa</label>
                                <select className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" value={formData.class_group_id} onChange={e => setFormData({...formData, class_group_id: e.target.value})}>
                                    <option value="">Wybierz grupę...</option>
                                    {groups.map(g => <option key={g.id} value={g.id}>{g.name}</option>)}
                                </select>
                            </div>
                        </div>

                        <div className="mt-6 flex justify-end space-x-3">
                            <button onClick={() => setIsModalOpen(false)} className="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Anuluj</button>
                            <button onClick={saveLesson} className="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition">Zatwierdź plan</button>
                        </div>
                    </div>
                </div>
            )}

            {isDetailsModalOpen && selectedEvent && (
                <div className="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-[1000]">
                    <div className="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md border-t-4 border-indigo-600">
                        <h2 className="text-2xl font-bold text-gray-800 mb-4">{selectedEvent.title}</h2>
                        <div className="space-y-3 mb-6 text-gray-700">
                            <p><strong>Prowadzący:</strong> {selectedEvent.teacherName}</p>
                            <p><strong>Przedmiot:</strong> {selectedEvent.subjectName}</p>
                            <p><strong>Grupa:</strong> {selectedEvent.groupName}</p>
                            <p><strong>Godziny:</strong> {selectedEvent.start?.toLocaleTimeString('pl-PL')} - {selectedEvent.end?.toLocaleTimeString('pl-PL')}</p>
                        </div>
                        <div className="mt-4 flex justify-end">
                            <button onClick={() => setIsDetailsModalOpen(false)} className="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Zamknij
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default CalendarApp;