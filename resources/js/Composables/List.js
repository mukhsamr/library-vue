export default function (obj) {

    let array = (typeof obj == 'object')
        ? Object.values(obj)
        : obj

    let list = `<ul class="list-disc ml-4">`
    array.forEach(e => {
        list += `<li>${e}</li>`
    })

    return list += `</ul>`
}