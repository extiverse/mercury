import { extend } from 'flarum/extend';
import HeaderSecondary from 'flarum/admin/components/HeaderSecondary';
import LinkButton from "flarum/common/components/LinkButton";

export default function () {
    extend(HeaderSecondary.prototype, 'items', (items) => {
        const token = app.data.settings['extiverse-mercury.token'] || null;
        let label;
        let icon;
        const updates = app.data.settings['extiverse-mercury.updates-required'];

        if (! token) {
            label = app.translator.trans('extiverse-mercury.admin.header-secondary.no-token');
            icon = 'fas fa-exclamation-triangle';
        } else {
            label = app.translator.trans('extiverse-mercury.admin.header-secondary.updates', {count: updates});
            icon = updates > 0 ? 'fas fa-exclamation-triangle' : 'fas fa-check-square';
        }

        items.add('extiverse-mercury',
            <LinkButton href="https://docs.flarum.org/troubleshoot.html" icon={icon} external={true} target="_blank">
                {label}
            </LinkButton>,
            10
        );
    });
}
