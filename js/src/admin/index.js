import app from 'flarum/app';

import HeaderSecondary from './extend/HeaderSecondary';
import ExtensionsUpdatesPage from "./Pages/ExtensionsUpdatesPage";

app.initializers.add('extiverse-mercury', () => {
    const link = "https://extiverse.com/auth/mercury?community=" + window.location.host;

    app.extensionData
        .for('extiverse-mercury')
        .registerSetting({
            setting: 'extiverse-mercury.token',
            type: 'text',
            label: app.translator.trans('extiverse-mercury.admin.settings.token',{a: <a href={link} target="_blank" />}),
            help: app.translator.trans('extiverse-mercury.admin.settings.token-description',{a: <a href={link} target="_blank" />})
        })
        .registerPage(ExtensionsUpdatesPage);

    HeaderSecondary();
});
