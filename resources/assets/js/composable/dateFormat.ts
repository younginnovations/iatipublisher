import moment from 'moment';

function dateFormat(date: Date, format = 'MMMM DD, YYYY' as string) {
  let format_date = format;

  switch (format_date) {
    case 'fromNow':
      format_date = moment(date).fromNow();
      break;
    default:
      format_date = moment(date).format('MMMM DD, YYYY');
  }

  return format_date;
}

export default dateFormat;
