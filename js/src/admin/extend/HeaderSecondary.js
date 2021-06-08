import { extend } from 'flarum/extend';
import HeaderSecondary from 'flarum/admin/components/HeaderSecondary';
import LinkButton from "flarum/common/components/LinkButton";

export default function () {
    extend(HeaderSecondary.prototype, 'items', (items) => {
        const token = app.data.settings['extiverse-mercury.token'] || null;
        const updates = Number(app.data.settings['extiverse-mercury.updates-required']);
        let label, icon, warning;

        if (! token) {
            label = app.translator.trans('extiverse-mercury.admin.header-secondary.no-token');
            icon = 'fas fa-exclamation-triangle';
            warning = true;
        } else {
            label = app.translator.trans('extiverse-mercury.admin.header-secondary.updates', {count: updates});
            warning = updates > 0;
            icon = warning ? 'fas fa-exclamation-triangle' : 'fas fa-thumbs-up';
        }

        items.add('extiverse-mercury',
            <LinkButton className={'ExtiverseMercuryButton Button ' + (warning && 'Button--danger')} href={app.route('extension', { id: 'extiverse-mercury' })} icon={icon}>
                {label}
            </LinkButton>,
            10
        );
    });
}
