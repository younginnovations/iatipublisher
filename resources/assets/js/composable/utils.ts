import Location from 'Interfaces/utils';

function getLocation(data: Location[]) {
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

export default getLocation;
