import Location from 'Interfaces/utils';

export function getLocation(data: Location[]) {
  let locations: string[] = [];

  locations = data.map((item) => {
    return item.reference;
  });

  const lastLocation = locations.slice(-1)[0];
  locations = locations.slice(0, -1);

  if (locations.length > 0) {
    return locations.join(', ') + ' ' + 'and' + ' ' + lastLocation;
  } else {
    return lastLocation;
  }
}

export function countDocumentLink(document_link) {
  let documentCount = 0;

  for (const document in document_link) {
    const result = reduceDocumentLink(document_link[document], []);

    if (!result.every((item) => item === null)) {
      documentCount++;
    }
  }

  return documentCount;
}

export function reduceDocumentLink(document_link, values) {
  if (typeof document_link === 'object' && document_link) {
    for (const key in document_link) {
      values.concat(reduceDocumentLink(document_link[key], values));
    }
  } else {
    values.push(document_link);
  }

  return values;
}

export function isJson(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

export function snakeCaseToSentenceCase(str) {
  const words = str.split('_');
  let sentence =
    words[0].charAt(0).toUpperCase() + words[0].slice(1).toLowerCase();

  for (let i = 1; i < words.length; i++) {
    sentence += ' ' + words[i].toLowerCase();
  }

  return sentence;
}

export function kebabCaseToSnakecase(str) {
  return str.replace(/-/g, '_');
}

export function truncateText(text, maxLength) {
  if (text.length > maxLength) {
    return text.substring(0, maxLength) + '...';
  }
  return text;
}
