export default class PictureService {
    constructor(axios) {
        this.axios = axios;
    }

    save(picture) {
        return this.axios.post('/api/picture', picture);
    }

    get(reference) {
        return this.axios.get(['/api/picture/reference', reference].join('/'));
    }

    search(criteria) {
        return this.axios.get(['/api/picture', criteria.toQuery()].join('?'));
    }
}