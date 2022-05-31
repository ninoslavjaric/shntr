import * as Run from 'run-sdk';
interface Credentials {
    private: string;
    public: string;
    address: string;
}
export declare class AppService {
    private readonly superRunner;
    constructor();
    getHello(): string;
    getSuperRunner(): Run;
    getPurse(): Promise<Credentials>;
}
export {};
