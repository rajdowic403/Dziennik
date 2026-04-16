import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

const CalendarApp = () => {
 
    const [teachers, setTeachers] = useState([]);
    const [subjects, setSubjects] = useState([]);
    const [groups, setGroups] = useState([]);
    
   
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [formData, setFormData] = useState({
        subject_id: '',
        teacher_id: '',
        class_group_id: '',
        start: '',
        end: ''
    });

    
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

    // Zapisywanie lekcji
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
        <div className="calendar-container bg-white p-4 shadow-lg rounded-lg">
            <FullCalendar
                plugins={[timeGridPlugin, interactionPlugin]}
                initialView="timeGridWeek"
                selectable={true}
                select={handleSelect}
                slotMinTime="08:00:00"
                slotMaxTime="21:00:00"
                allDaySlot={false}
                locale="pl"
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
                                <label className="block text-sm font-medium text-gray-700">Przedmiot / Moduł</label>
                                <select 
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    onChange={e => setFormData({...formData, subject_id: e.target.value})}
                                >
                                    <option value="">Wybierz przedmiot...</option>
                                    {subjects.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
                                </select>
                            </div>

                            
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Prowadzący</label>
                                <select 
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    onChange={e => setFormData({...formData, teacher_id: e.target.value})}
                                >
                                    <option value="">Wybierz prowadzącego...</option>
                                    {teachers.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                                </select>
                            </div>

                            {/* Wybór Grupy */}
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Grupa Studencka</label>
                                <select 
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    onChange={e => setFormData({...formData, class_group_id: e.target.value})}
                                >
                                    <option value="">Wybierz grupę...</option>
                                    {groups.map(g => <option key={g.id} value={g.id}>{g.name}</option>)}
                                </select>
                            </div>
                        </div>

                        <div className="mt-6 flex justify-end space-x-3">
                            <button 
                                onClick={() => setIsModalOpen(false)}
                                className="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition"
                            >
                                Anuluj
                            </button>
                            <button 
                                onClick={saveLesson}
                                className="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition"
                            >
                                Zatwierdź plan
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default CalendarApp;