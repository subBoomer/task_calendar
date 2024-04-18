import { TZDate } from '@toast-ui/calendar';

import { addDate, addHours, subtractDate } from './utils';

const today = new TZDate();

export const events = loadEventsFromLocalStorage();

// Function to load events from local storage
function loadEventsFromLocalStorage() {
  try {
    const storedEvents = localStorage.getItem('events');
    console.log('Stored events:', storedEvents); // Log the stored events
    if (storedEvents !== null && storedEvents !== undefined) {
      console.log('Parsing stored events...'); // Log when parsing starts
      return JSON.parse(storedEvents);
    } else {
      console.log('No stored events found. Initializing to empty array.');
      return [];
    }
  } catch (error) {
    console.error('Error retrieving events from local storage:', error);
    return [];
  }
}

// Function to save events to local storage
export function saveEventsToLocalStorage() {
  try {
    localStorage.setItem('events', JSON.stringify(events));
  } catch (error) {
    console.error('Error saving events to local storage:', error);
  }
}

// Function to retrieve events from local storage
const retrieveEventsFromLocalStorage = () => {
  try {
    const storedEvents = localStorage.getItem('events');
    console.log('Stored events:', storedEvents);
    if (storedEvents) {
      console.log('Parsing stored events...');
      return JSON.parse(storedEvents);
    } else {
      console.log('No events found in local storage.');
      return [];
    }
  } catch (error) {
    console.error('Error retrieving events from local storage:', error);
    return [];
  }
};

// Function to add event
export const addEvent = (event) => {
  events.push(event);
  saveEventsToLocalStorage();
};

// Function to remove event
export const removeEvent = (eventId) => {
  const index = events.findIndex(event => event.id === eventId);
  if (index !== -1) {
    events.splice(index, 1);
    saveEventsToLocalStorage();
  }
};

// Function to check if time value is valid
const isValidTime = (time) => {
  return time instanceof Date && !isNaN(time.getTime());
};

// Ensure that time values are valid before saving to local storage
const saveEventWithValidTime = (event) => {
  if (isValidTime(event.start) && isValidTime(event.end)) {
    addEvent(event);
  } else {
    console.error('Invalid start or end time:', event);
  }
};

export const addEventWithValidTime = (event) => {
  if (event) {
    saveEventWithValidTime(event);
  } else {
    console.error('Event is empty');
  }
};

// Retrieve events from local storage when the module is loaded
events.push(...retrieveEventsFromLocalStorage());