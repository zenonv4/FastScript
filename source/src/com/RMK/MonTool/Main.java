package com.RMK.MonTool;

import java.io.FileInputStream;
import java.io.IOException;
import java.util.Properties;

import org.eclipse.swt.*;
import org.eclipse.swt.layout.*;
import org.eclipse.swt.widgets.*;
import org.eclipse.swt.browser.*;
import org.eclipse.swt.events.KeyAdapter;
import org.eclipse.swt.events.KeyEvent;

public class Main {
	static Display display = new Display();
	final static Shell shell = new Shell(display,SWT.ON_TOP | SWT.NO_TRIM | SWT.NO_SCROLL);
	final static Browser browser = new Browser(shell, SWT.NO_SCROLL);
	static Properties WebProps = new Properties();
	public static void main(String[] args) throws IOException {
		// create and load default properties
		
		FileInputStream in = new FileInputStream("Web.properties");
		WebProps.load(in);
		in.close();

		FillLayout fillLayout = new FillLayout();
		fillLayout.type = SWT.VERTICAL;

		shell.setLayout(fillLayout);
		shell.setMaximized(true);
		shell.setBounds(Display.getDefault().getPrimaryMonitor().getBounds());
		shell.open();

		browser.addKeyListener(new KeyAdapter() {
			private int keynum;
			public void keyPressed(KeyEvent e) {
				if (e.keyCode == SWT.END)
				{
					keynum += 1;
					if(keynum == 4)
					{
						Main.shell.close();
					}
				}
				if (e.keyCode == SWT.DEL)
				{
					keynum += 0;
				}
				if (e.keyCode == SWT.HOME)
				{
					Main.this.browser.setUrl(WebProps.getProperty("url"));
				}
			}
		});
		browser.setUrl(WebProps.getProperty("url"));

		while (!shell.isDisposed()) {
			if (!display.readAndDispatch())
				display.sleep();
		}
		display.dispose();
	}

}