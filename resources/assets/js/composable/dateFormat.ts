import moment from 'moment';

function dateFormat(date: Date, format: string) {
  const format_date = moment(date).format(format);
  return format_date;
}

export default dateFormat;
