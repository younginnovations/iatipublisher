/**
 * Get current activity title
 *
 * @return title text
 */

function getActivityTitle(
  data: { language: string; narrative: string }[],
  language: string
) {
  let title = 'Untitled';

  // title return if language exist in data
  if(data){
    for (const t of data) {
      if (t.language && t.language === language) {
        title = t.narrative && t.narrative !== '' ? t.narrative : 'Untitled';
        return title;
      }
    }
  
    // default title return if language does not exist in data
    title = data['0'].narrative && data['0'].narrative !== '' ? data['0'].narrative : 'Untitled';
  }
  return title;
}

export default getActivityTitle;
