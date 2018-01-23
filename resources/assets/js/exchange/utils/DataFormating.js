export function formatField(type, value) {
	switch(type) {
		case 'int': return parseInt(value);
		case 'float': return parseFloat(value);
		default: return value;
	}
}