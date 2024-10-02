import axios from 'axios';

const API_URL = 'http://localhost:8000/api';  // Point to Laravel backend

export const getRaceSchedule = async () => {
  return axios.get(`${API_URL}/schedule`);
};

export const getTeamStandings = async () => {
  return axios.get(`${API_URL}/standings`);
};

export const getLiveRaceUpdates = async () => {
  return axios.get(`${API_URL}/live`);
};
