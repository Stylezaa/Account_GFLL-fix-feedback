// default input current date
export const defaultDate = () => {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    return `${year}-${month < 10 ? `0${month}` : month}-${day < 10 ? `0${day}` : day}`;
}

// get ago date from current date
export const getAgoDate = (ago) => {
    const date = new Date();
    date.setDate(date.getDate() - ago);
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    return `${year}-${month < 10 ? `0${month}` : month}-${day < 10 ? `0${day}` : day}`;
}

// get current month
export const getCurrentMonth = () => {
    const date = new Date();
    const month = date.getMonth() + 1;
    return month < 10 ? `0${month}` : month;
}

// get ago month from current month
export const getAgoMonth = (ago) => {
    const date = new Date();
    date.setMonth(date.getMonth() - ago);
    const month = date.getMonth() + 1;
    return month < 10 ? `0${month}` : month;
}

// get current year
export const getCurrentYear = () => {
    const date = new Date();
    return date.getFullYear();
}

// get ago year from current year
export const getAgoYear = (ago) => {
    const date = new Date();
    date.setFullYear(date.getFullYear() - ago);
    return date.getFullYear();
}

// get start date of month
export const getStartDateOfMonth = (month, year) => {
    return `${year}-${month}-01`;
}

// get end date of month
export const getEndDateOfMonth = (month, year) => {
    // get last day of month
    const lastDay = new Date(year, month, 0).getDate();
    return `${year}-${month}-${lastDay}`;
}

// get start date of year
export const getStartDateOfYear = (year) => {
    return `${year}-01-01`;
}

// get end date of year
export const getEndDateOfYear = (year) => {
    // get last day of year
    const lastDay = new Date(year, 12, 0).getDate();
    return `${year}-12-${lastDay}`;
}

// get current month year 
export const getCurrentMonthYear = () => {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    return `${year}-${month < 10 ? `0${month}` : month}`;
}

// get ago month year
export const getAgoMonthYear = (ago) => {
    const date = new Date();
    date.setMonth(date.getMonth() - ago);
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    return `${year}-${month < 10 ? `0${month}` : month}`;
}