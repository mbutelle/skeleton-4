export default class Criteria {
    constructor(criteria) {
        this.criteria = criteria;
    }

    add(criteria, value) {
        this.criteria[criteria] = value;
    }

    toQuery() {
        return Object.entries(this.criteria).map((value) => {
            if (null === value[1]) {
                return '';
            }

            return value[0] + '=' + encodeURIComponent(value[1])
        }).filter(v => v !== '').join('&');
    }
}