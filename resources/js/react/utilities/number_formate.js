// comman number
export const numberFormat = (value) => {
    // ex: 1000000 => 1,000,000
    return new Intl.NumberFormat().format(value);
}

// comman number with decimal
export const numberFormatWithDecimal = (value) => {
    // ex: 1000000 => 1,000,000.00
    return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(value);
}