export default function filterNotes(notes, filter) {
    let search = filter.toLowerCase()

    return notes.filter(note => {
        let date = new Date(note['created_at'])

        return note['title'].toLowerCase().indexOf(search) !== -1 ||
            note['body'].toLowerCase().indexOf(search) !== -1 ||
            date.toLocaleDateString().indexOf(search) !== -1
    })
}