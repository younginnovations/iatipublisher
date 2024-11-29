import moment from 'moment';

function dateFormat(date: Date, format = 'MMMM DD, YYYY' as string) {
  let format_date;

  switch (format) {
    case 'fromNow':
      format_date = date ? moment(date).fromNow() : '';
      break;

    case 'calendar':
      format_date = date ? moment(date).calendar() : '';
      break;

    default:
      format_date = date ? moment(date).format(format) : '';
  }

  return format_date;
}

export default dateFormat;
