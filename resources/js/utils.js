import { TZDate } from '@toast-ui/calendar';

// Function to clone a date object
export function clone(date) {
  return new TZDate(date); // Create a new TZDate object with the same value as the provided date object
}

// Function to add hours to a date object
export function addHours(d, step) {
  const date = clone(d); // Clone the provided date object
  date.setHours(d.getHours() + step); // Add the specified number of hours to the cloned date object

  return date; // Return the modified date object
}

// Function to add days to a date object
export function addDate(d, step) {
  const date = clone(d); 
  date.setDate(d.getDate() + step); // Add the specified number of days to the cloned date object

  return date;
}

// Function to subtract days from a date object
export function subtractDate(d, steps) {
  const date = clone(d);
  date.setDate(d.getDate() - steps); // Subtract the specified number of days from the cloned date object

  return date;
}