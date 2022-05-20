import app from 'flarum/admin/app';

import HeaderSecondary from './extend/HeaderSecondary';
import ExtensionsUpdatesPage from "./Pages/ExtensionsUpdatesPage";
import Link from 'flarum/common/components/Link';

app.initializers.add('extiverse-mercury', () => {
    const link = "https://extiverse.com/auth/mercury?community=" + window.location.host;

    app.extensionData
        .for('extiverse-mercury')
        .registerSetting({
            setting: 'extiverse-mercury.token',
            type: 'text',
            label: app.translator.trans('extiverse-mercury.admin.settings.token',{a: <Link href={link} target="_blank" external={true} />}),
            help: app.translator.trans('extiverse-mercury.admin.settings.token-description',{a: <Link href={link} target="_blank" external={true} />})
        })
        .registerPage(ExtensionsUpdatesPage);

    HeaderSecondary();
});
